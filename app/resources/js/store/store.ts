import { configureStore } from '@reduxjs/toolkit';

import cityReducer from '../store/City';
<<<<<<< HEAD
import warehouseObject from '../store/warehouseObject'
=======
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

export const store = configureStore({
  reducer: {
    cities: cityReducer,
<<<<<<< HEAD
    warehouseObjects: warehouseObject,
=======
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
  },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;