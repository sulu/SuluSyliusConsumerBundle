// @flow
import React, {Fragment} from 'react';
import {action, autorun, toJS, observable, untracked, computed} from 'mobx';
import {observer} from 'mobx-react';
import equals from 'fast-deep-equal';
import {MultiItemSelection} from 'sulu-admin-bundle/components';
import {translate} from 'sulu-admin-bundle/utils';
import type {IObservableValue} from 'mobx';
import {MultiSelectionStore} from 'sulu-admin-bundle/stores';
import MultiMediaSelectionOverlay from 'sulu-media-bundle/containers/MultiMediaSelectionOverlay';
import MultiItemSelectionItem from './MultiItemSelectionItem';
import type {MediaReference} from './types';

type Props = {|
    disabled: boolean,
    locale: IObservableValue<string>,
    onChange: (value: Array<MediaReference>) => void,
    value: Array<MediaReference>,
|}

@observer
export default class SyliusMultiMediaSelection extends React.Component<Props> {
    static defaultProps = {
        disabled: false,
        value: [],
    };

    mediaSelectionStore: MultiSelectionStore;
    changeDisposer: () => void;
    changeAutorunInitialized: boolean = false;

    @observable overlayOpen: boolean = false;

    getValueEntry(mediaId: number)
    {
        const {value} = this.props;

        const media = value.find((mediaReference) => mediaReference.mediaId === mediaId);

        return media ? media : {
            mediaId: mediaId,
            type: '',
            syliusId: null,
            syliusPath: null,
            active: true,
        };
    }

    constructor(props: Props) {
        super(props);

        const {locale, value} = this.props;
        const selectedMediaIds = value.map((mediaReference) => mediaReference.mediaId);

        this.mediaSelectionStore = new MultiSelectionStore('media', selectedMediaIds, locale);
        this.changeDisposer = autorun(() => {
            const {onChange, value} = untracked(() => this.props);
            const loadedMediaIds = (this.mediaSelectionStore.items.map((item) => item.id));
            const selectedMediaIds = value.map((mediaReference) => mediaReference.mediaId);

            if (!this.changeAutorunInitialized) {
                this.changeAutorunInitialized = true;
                return;
            }

            if (equals(selectedMediaIds, toJS(loadedMediaIds))) {
                return;
            }

            const newValue = loadedMediaIds.map((mediaId) => {
                return this.getValueEntry(mediaId);
            });

            onChange(newValue);
        });
    }

    componentDidUpdate() {
        const {
            locale,
            value,
        } = this.props;

        const newSelectedIds = value.map((mediaReference) => mediaReference.mediaId);
        const loadedSelectedIds = toJS(this.mediaSelectionStore.items.map((item) => item.id));

        newSelectedIds.sort();
        loadedSelectedIds.sort();
        if (!equals(newSelectedIds, loadedSelectedIds)) {
            this.mediaSelectionStore.loadItems(newSelectedIds);
        }
    }

    componentWillUnmount() {
        this.changeDisposer();
    }

    @action openMediaOverlay() {
        this.overlayOpen = true;
    }

    @action closeMediaOverlay() {
        this.overlayOpen = false;
    }

    getLabel(itemCount: number) {
        if (itemCount === 1) {
            return `1 ${translate('sulu_media.media_selected_singular')}`;
        } else if (itemCount > 1) {
            return `${itemCount} ${translate('sulu_media.media_selected_plural')}`;
        }

        return translate('sulu_media.select_media_plural');
    }

    handleRemove = (mediaId: number) => {
        this.mediaSelectionStore.removeById(mediaId);
    };

    handleSorted = (oldItemIndex: number, newItemIndex: number) => {
        this.mediaSelectionStore.move(oldItemIndex, newItemIndex);
    };

    handleOverlayOpen = () => {
        this.openMediaOverlay();
    };

    handleOverlayClose = () => {
        this.closeMediaOverlay();
    };

    handleOverlayConfirm = (selectedMedia: Array<Object>) => {
        this.mediaSelectionStore.set([...this.mediaSelectionStore.items, ...selectedMedia]);
        this.closeMediaOverlay();
    };

    handleMediaReferenceChange = (newMediaReference: MediaReference) => {
        const {onChange, value} = this.props;
        const newValue = toJS(value);
        newValue.forEach((mediaReference) => {
            if (mediaReference.mediaId === newMediaReference.mediaId) {
                mediaReference.type = newMediaReference.type;
                mediaReference.active = newMediaReference.active;
            }
        });

        onChange(newValue);
    };

    render() {
        const {locale, disabled} = this.props;

        const {
            loading,
            items,
        } = this.mediaSelectionStore;
        const label = (loading) ? '' : this.getLabel(items.length);

        return (
            <Fragment>
                <MultiItemSelection
                    disabled={!!disabled}
                    label={label}
                    leftButton={{
                        icon: 'su-image',
                        onClick: this.handleOverlayOpen,
                    }}
                    loading={loading}
                    onItemsSorted={this.handleSorted}
                >
                    {items.map((media, index) => {
                        return (
                            <MultiItemSelection.Item
                                id={media.id}
                                index={index + 1}
                                key={media.id}
                            >
                                <MultiItemSelectionItem
                                    media={media}
                                    mediaReference={this.getValueEntry(media.id)}
                                    onMediaReferenceChange={this.handleMediaReferenceChange}
                                    onRemove={this.handleRemove}
                                />
                            </MultiItemSelection.Item>
                        );
                    })}
                </MultiItemSelection>
                <MultiMediaSelectionOverlay
                    excludedIds={(items.map((item) => item.id))}
                    locale={locale}
                    onClose={this.handleOverlayClose}
                    onConfirm={this.handleOverlayConfirm}
                    open={this.overlayOpen}
                />
            </Fragment>
        );
    }
}
