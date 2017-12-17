import ProductStore from './product/store';
import AssemblyStore from './assembly/store';

const stores = {
  productStore: new ProductStore(),
  assemblyStore: new AssemblyStore()
};

export default stores;