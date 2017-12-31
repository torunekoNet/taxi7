import AppStore from './appStore';
import RentalStore from './rental/store';
import VehicleStore from './vehicle/store';
import DriverStore from './driver/store';

const rentalStore = new RentalStore();

const stores = {
    appStore: new AppStore(),
    rentalStore: rentalStore,
    vehicleStore: new VehicleStore(rentalStore),
    driverStore: new DriverStore(rentalStore)
};

export default stores;