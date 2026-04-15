import { configureStore } from '@reduxjs/toolkit';

import { authApi } from '@/api/authApi';
import { cellPriceApi } from '@/api/cellPriceApi';

import { cellApi } from '../api/cellApi';
import { cityApi } from '../api/cityApi';

import authReducer from './Auth'

export const store = configureStore({
  reducer: {
    [authApi.reducerPath]: authApi.reducer,
    [cityApi.reducerPath]: cityApi.reducer,
    [cellApi.reducerPath]: cellApi.reducer,

    [cellPriceApi.reducerPath]: cellPriceApi.reducer,
    auth:authReducer,
  },
  middleware: (getDefaultMiddleware) => {
    return getDefaultMiddleware().concat(
      authApi.middleware,
      cellApi.middleware,
      cityApi.middleware,
      cellPriceApi.middleware
    );
  },

},


);

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;