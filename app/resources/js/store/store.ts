import { configureStore } from '@reduxjs/toolkit';

import cityReducer from '../store/City';
import warehouseObject from '../store/warehouseObject'

import cellReducer from './CellObject'


export const store = configureStore({
  reducer: {
    cells: cellReducer,
    cities: cityReducer,
    warehouseObjects: warehouseObject,


  },
});
console.log('Redux store keys:', Object.keys(store.getState()));

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
console.log('Redux store keys:', store);