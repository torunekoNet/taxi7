import AppStore from './appStore';
import RentalStore from './rental/store';
import StatisticsStore from './statistics/store';
import DriverStore from './driver/store';

const rentalStore = new RentalStore();

const stores = {
    appStore: new AppStore(),
    rentalStore: rentalStore,
    statisticsStore: new StatisticsStore(rentalStore),
    driverStore: new DriverStore(rentalStore)
};

export default stores;