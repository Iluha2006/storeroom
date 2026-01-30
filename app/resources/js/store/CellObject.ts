// store/cellSlice.ts
import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import axios, { AxiosError } from 'axios';

import { ICell } from '../types/Cell';

import type { AppDispatch } from './store';

interface CellState {
  cells: ICell[];
  loading: boolean;
  error: string | null;
  successMessage: string | null;
}

const initialState: CellState = {
  cells: [],
  loading: false,
  error: null,
  successMessage: null
};

const cellSlice = createSlice({
  name: 'cells',
  initialState,
  reducers: {
    setCells: (state, action: PayloadAction<ICell[]>) => {
      state.cells = action.payload;
    },
    setLoading: (state, action: PayloadAction<boolean>) => {
      state.loading = action.payload;
    },
    setError: (state, action: PayloadAction<string | null>) => {
      state.error = action.payload;
    },
    clearMessages: (state) => {
      state.error = null;
      state.successMessage = null;
    }
  }
});



export const fetchCells = (citySlug: string, objectSlug: string) =>
    async (dispatch: AppDispatch) => {
      try {
        dispatch(setLoading(true));
        dispatch(clearMessages());

        const response = await axios.get(`/api/city/${citySlug}/${objectSlug}/available`);

        console.log('API Response for cells:', response.data);

        if (response.data.success) {
          dispatch(setCells(response.data.data));
        }

        console.log(response.data);
        return response.data
      } catch (error) {
        const axiosError = error as AxiosError<{ message?: string }>;
        const errorMessage = axiosError.response?.data?.message || 'Ошибка загрузки ячеек';
        dispatch(setError(errorMessage));
      } finally {
        dispatch(setLoading(false));
      }
    };
    export const fetchCellsByCity = (citySlug: string) =>
        async (dispatch: AppDispatch) => {
          try {
            dispatch(setLoading(true));
            const response = await axios.get(`/api/city/${citySlug}/cells`);

            if (response.data.success) {
              dispatch(setCells(response.data.data));
            }
          } catch (error) {
              console.error("ошибка " , error)
          } finally {
            dispatch(setLoading(false));
          }
        };


        export const fetchCellsShow = (citySlug: string) =>
            async (dispatch: AppDispatch) => {
              try {
                dispatch(setLoading(true));
                const response = await axios.get(`/cellObject/${citySlug}`);

                if (response.data.success) {
                  dispatch(setCells(response.data.data));
                }
              } catch (error) {
                  console.error("ошибка " , error)
              } finally {
                dispatch(setLoading(false));
              }
            };
export const { setCells, setLoading, setError, clearMessages } = cellSlice.actions;
export default cellSlice.reducer;