// @flow
import React from 'react';
import Input from 'sulu-admin-bundle/components/Input';
import MimeTypeIndicator from 'sulu-media-bundle/components/MimeTypeIndicator';
import multiItemSelectionItemStyle from './multiItemSelectionItem.scss';
import type {MediaReference} from './types';
import Icon from 'sulu-admin-bundle/components/Icon';

type Props = {|
    media: Object,
    mediaReference: MediaReference,
    onRemove: (mediaId: number) => void,
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

    handleRemove = () => {
        const {onRemove, media} = this.props;
        onRemove(media.id);
    };

    render() {
        const {
            media,
            mediaReference,
        } = this.props;

        return (
            <div className={multiItemSelectionItemStyle.mediaItemContainer}>
                <div className={multiItemSelectionItemStyle.mediaItem}>
                    {media.thumbnails[THUMBNAIL_SIZE]
                        ? <img
                            alt={media.title}
                            className={multiItemSelectionItemStyle.thumbnailImage}
                            src={media.thumbnails[THUMBNAIL_SIZE]}
                        />
                        : <MimeTypeIndicator
                            height={25}
                            iconSize={16}
                            mimeType={media.mimeType}
                            width={25}
                        />
                    }
                    <div className={multiItemSelectionItemStyle.mediaTitle}>{media.title}</div>
                </div>
                <div className={multiItemSelectionItemStyle.mediaTitle}>
                    <Input value={mediaReference.type} onChange={this.handleTypeChange} disabled={!!mediaReference.syliusId} />
                </div>
                <div className={multiItemSelectionItemStyle.buttons}>
                    {mediaReference.syliusId
                        ?
                        <button
                            className={multiItemSelectionItemStyle.button}
                            onClick={this.handleStatusChange}
                            type='button'
                        >
                            <Icon name={DISABLE_ICON} />
                        </button>
                        :
                        <button
                            className={multiItemSelectionItemStyle.button}
                            onClick={this.handleRemove}
                            type='button'
                        >
                            <Icon name={REMOVE_ICON} />
                        </button>
                    }
                </div>
            </div>
        );
    }
}
