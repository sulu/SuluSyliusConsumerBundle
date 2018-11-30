// @flow
import React from 'react';
import {MultiItemSelection} from 'sulu-admin-bundle/components';
import Input from 'sulu-admin-bundle/components/Input';
import MimeTypeIndicator from 'sulu-media-bundle/components/MimeTypeIndicator';
import syliusMultiMediaSelectionStyle from './syliusMultiMediaSelection.scss';
import type {MediaReference} from './types';
import Icon from 'sulu-admin-bundle/components/Icon';

type Props = {|
    media: Object,
    mediaReference: MediaReference,
    onRemove: (value: Array<MediaReference>) => void,
    onMediaReferenceChange: (value: MediaReference) => void,
|}

const THUMBNAIL_SIZE = 'sulu-25x25';
const REMOVE_ICON = 'su-trash-alt';
const DISABLE_ICON = 'su-eye';

export default class MultiItemSelectionItem extends React.PureComponent<Props> {
    handleStatusChange = () => {
        const {mediaReference, onMediaReferenceChange} = this.props;
        const newValue = {...mediaReference};
        newValue.enabled = !newValue.enabled;

        onMediaReferenceChange(newValue);
    };

    handleTypeChange = (type: string) => {
        const {mediaReference, onMediaReferenceChange} = this.props;
        const newValue = {...mediaReference};
        newValue.type = type;

        onMediaReferenceChange(newValue);
    };

    render() {
        const {
            media,
            mediaReference,
            onRemove,
        } = this.props;

        return (
            <MultiItemSelection.Item
                id={media.id}
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
                        <div className={syliusMultiMediaSelectionStyle.mediaTitle}>
                            <Input value={mediaReference.type} onChange={this.handleTypeChange} />
                        </div>
                    </div>
                    <div className={syliusMultiMediaSelectionStyle.buttons}>
                        {mediaReference.syliusId
                            ?
                            <button
                                className={syliusMultiMediaSelectionStyle.button}
                                onClick={this.handleStatusChange}
                                type='button'
                            >
                                <Icon name={DISABLE_ICON} />
                            </button>
                            :
                            <button
                                className={syliusMultiMediaSelectionStyle.button}
                                onClick={onRemove}
                                type='button'
                            >
                                <Icon name={REMOVE_ICON} />
                            </button>
                        }
                    </div>
                </div>
            </MultiItemSelection.Item>
        );
    }
}
