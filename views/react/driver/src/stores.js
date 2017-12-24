import AppStore from './appStore';
import RentalStore from './rental/store';
import VehicleStore from './vehicle/store';
import DriverStore from './driver/store';

const stores = {
    appStore: new AppStore(),
    rentalStore: new RentalStore(),
    vehicleStore: new VehicleStore(),
    driverStore: new DriverStore()
};

export default stores;