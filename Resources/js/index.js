// @flow
import {bundleReady} from 'sulu-admin-bundle/services';
import {fieldRegistry} from 'sulu-admin-bundle/containers';
import {SyliusMediaSelection} from './containers/Form';

fieldRegistry.add('sylius_media_selection', SyliusMediaSelection);

bundleReady();
