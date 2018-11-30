// @flow
import React from 'react';
import {observer} from 'mobx-react';
import type {FieldTypeProps} from 'sulu-admin-bundle/types';
import SyliusMultiMediaSelection from '../../SyliusMultiMediaSelection';
import type {MediaReference} from '../../SyliusMultiMediaSelection';

@observer
export default class MediaSelection extends React.Component<FieldTypeProps<Value>> {
    handleChange = (value: Array<MediaReference>) => {
        const {onChange, onFinish} = this.props;

        onChange(value);
        onFinish();
    };

    render() {
        const {formInspector, disabled, value} = this.props;

        if (!formInspector || !formInspector.locale) {
            throw new Error('The media selection needs a locale to work properly');
        }

        const {locale} = formInspector;

        return (
            <SyliusMultiMediaSelection
                disabled={!!disabled}
                locale={locale}
                onChange={this.handleChange}
                value={value ? value : undefined}
            />
        );
    }
}