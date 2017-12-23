import AppStore from './appStore';
import ProductStore from './product/store';
import AssemblyStore from './assembly/store';

const stores = {
  appStore: new AppStore(),
  productStore: new ProductStore(),
  assemblyStore: new AssemblyStore()
};

export default stores;