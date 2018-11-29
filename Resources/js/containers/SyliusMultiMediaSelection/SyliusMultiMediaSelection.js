// @flow
import React, {Fragment} from 'react';
import {action, autorun, toJS, observable, untracked} from 'mobx';
import {observer} from 'mobx-react';
import equals from 'fast-deep-equal';
import {MultiItemSelection} from 'sulu-admin-bundle/components';
import {translate} from 'sulu-admin-bundle/utils';
import type {IObservableValue} from 'mobx';
import MultiMediaSelectionStore from 'sulu-media-bundle/stores/MultiMediaSelectionStore';
import MultiMediaSelectionOverlay from 'sulu-media-bundle/containers/MultiMediaSelectionOverlay';
import MimeTypeIndicator from 'sulu-media-bundle/components/MimeTypeIndicator';
import syliusMultiMediaSelectionStyle from './syliusMultiMediaSelection.scss';
import type {Value} from './types';
import Icon from "sulu-admin-bundle/components/Icon";

type Props = {|
    disabled: boolean,
    locale: IObservableValue<string>,
    onChange: (selectedIds: Value) => void,
    value: Value,
|}

const THUMBNAIL_SIZE = 'sulu-25x25';
const REMOVE_ICON = 'su-trash-alt';
const DISABLE_ICON = 'su-eye';

@observer
export default class SyliusMultiMediaSelection extends React.Component<Props> {
    static defaultProps = {
        disabled: false,
        value: {ids: []},
    };

    mediaSelectionStore: MultiMediaSelectionStore;
    changeDisposer: () => void;
    changeAutorunInitialized: boolean = false;

    @observable overlayOpen: boolean = false;

    constructor(props: Props) {
        super(props);

        const {locale, value} = this.props;

        this.mediaSelectionStore = new MultiMediaSelectionStore(value.ids, locale);
        this.changeDisposer = autorun(() => {
            const {onChange, value} = untracked(() => this.props);
            const loadedMediaIds = this.mediaSelectionStore.selectedMediaIds;

            if (!this.changeAutorunInitialized) {
                this.changeAutorunInitialized = true;
                return;
            }

            if (equals(toJS(value.ids), toJS(loadedMediaIds))) {
                return;
            }

            onChange({ids: loadedMediaIds});
        });
    }

    componentDidUpdate() {
        const {
            locale,
            value,
        } = this.props;

        const newSelectedIds = toJS(value.ids);
        const loadedSelectedIds = toJS(this.mediaSelectionStore.selectedMediaIds);

        newSelectedIds.sort();
        loadedSelectedIds.sort();
        if (!equals(newSelectedIds, loadedSelectedIds)) {
            this.mediaSelectionStore.loadSelectedMedia(newSelectedIds, locale);
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
        selectedMedia.forEach((media) => this.mediaSelectionStore.add(media));
        this.closeMediaOverlay();
    };

    render() {
        const {locale, disabled} = this.props;

        const {
            loading,
            selectedMedia,
            selectedMediaIds,
        } = this.mediaSelectionStore;
        const label = (loading) ? '' : this.getLabel(selectedMedia.length);

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
                    {selectedMedia.map((media, index) => {
                        return (
                            <MultiItemSelection.Item
                                id={media.id}
                                index={index + 1}
                                key={media.id}
                            >
                                <div className={syliusMultiMediaSelectionStyle.mediaItemContainer}>
                                    <div className={syliusMultiMediaSelectionStyle.mediaItem}>
                                        {media.thumbnails[THUMBNAIL_SIZE]
                                            ? <img
                                                alt={media.title}
                                                className={syliusMultiMediaSelectionStyle.thumbnailImage}
                                                src={media.thumbnails[THUMBNAIL_SIZE]}
                                            />
                                            : <MimeTypeIndicator
                                                height={25}
                                                iconSize={16}
                                                mimeType={media.mimeType}
                                                width={25}
                                            />
                                        }
                                        <div className={syliusMultiMediaSelectionStyle.mediaTitle}>{media.title}</div>
                                    </div>
                                    <div className={syliusMultiMediaSelectionStyle.buttons}>
                                        <button
                                            className={syliusMultiMediaSelectionStyle.button}
                                            onClick={this.handleRemove}
                                            type="button"
                                        >
                                            <Icon name={REMOVE_ICON} />
                                        </button>
                                        <button
                                            className={syliusMultiMediaSelectionStyle.button}
                                            onClick={this.handleRemove}
                                            type="button"
                                        >
                                            <Icon name={DISABLE_ICON} />
                                        </button>
                                    </div>
                                </div>
                            </MultiItemSelection.Item>
                        );
                    })}
                </MultiItemSelection>
                <MultiMediaSelectionOverlay
                    excludedIds={selectedMediaIds}
                    locale={locale}
                    onClose={this.handleOverlayClose}
                    onConfirm={this.handleOverlayConfirm}
                    open={this.overlayOpen}
                />
            </Fragment>
        );
    }
}
