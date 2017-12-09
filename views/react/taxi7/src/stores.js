import AppStore from './application/store';
import OverviewStore from './overview/store';
import GroupStore from './groupmanager/store';
import UserStore from './usermanager/store';
import PolicyStore from './policy/store';

const policyStore = new PolicyStore();
const groupStore = new GroupStore(policyStore);
const userStore = new UserStore(policyStore);

const stores = {
  appStore: new AppStore(),
  overviewStore: new OverviewStore(userStore, groupStore, policyStore),
  groupStore,
  userStore,
  policyStore
};

export default stores;