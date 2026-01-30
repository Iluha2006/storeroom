
import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import axios, { AxiosError } from 'axios';

import { IWarehouseObject } from '@/types/Object';

import type { AppDispatch } from './store'



interface WarehouseObjectState {
    objects: IWarehouseObject[];
    loading: boolean;
    error: string | null;
    successMessage: string | null;
}

const initialState: WarehouseObjectState = {
    objects: [],
    loading: false,
    error: null,
    successMessage: null
};

const warehouseObjectSlice = createSlice({
    name: 'warehouseObjects',
    initialState,
    reducers: {
        setWarehouseObjects: (state, action: PayloadAction<IWarehouseObject[]>) => {
            state.objects = action.payload;
        },



        setLoading: (state, action: PayloadAction<boolean>) => {
            state.loading = action.payload;
        },
        setError: (state, action: PayloadAction<string | null>) => {
            state.error = action.payload;
        },
        setSuccessMessage: (state, action: PayloadAction<string | null>) => {
            state.successMessage = action.payload;
        },
        clearMessages: (state) => {
            state.error = null;
            state.successMessage = null;
        },
    }
});


export const fetchWarehouseObjectsByCity = (citySlug: string) =>
    async (dispatch: AppDispatch): Promise<{success: boolean; data?: IWarehouseObject[]; error?: string}> => {
    try {
        dispatch(setLoading(true));
        dispatch(clearMessages());

        const response = await axios.get(`/api/city/${citySlug}/available`);

        if (response.data.success) {
            dispatch(setWarehouseObjects(response.data.data));
            dispatch(setLoading(false));
            return { success: true, data: response.data.data };
        } else {
            const errorMessage = 'Ошибка загрузки объектов';
            dispatch(setError(errorMessage));
            dispatch(setLoading(false));
            return { success: false, error: errorMessage };
        }
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;
        const errorMessage = axiosError.response?.data?.message
        dispatch(setLoading(false));
        return { success: false, error: errorMessage };
    }
};

export const fetchWarehouseObjectBySlug = (citySlug: string, objectSlug: string) =>
    async (dispatch: AppDispatch): Promise<{success: boolean; data?: IWarehouseObject; error?: string}> => {
    try {
        dispatch(setLoading(true));
        dispatch(clearMessages());
        const response = await axios.get(
            `/api/city/${citySlug}/${objectSlug}`
        );

        if (response.data.success) {
            dispatch(setWarehouseObjects(response.data.data ));
            dispatch(setLoading(false));
            return { success: true, data: response.data.data };
        } else {
            const errorMessage = response.data.message || 'Объект не найден';
            dispatch(setError(errorMessage));
            dispatch(setLoading(false));
            return { success: false, error: errorMessage };
        }
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;
        if (axiosError.response?.status === 404) {
            dispatch(setError('Объект не найден'));
        } else {
            const errorMessage = axiosError.response?.data?.message ||
                                axiosError.response?.data?.error ||
                                'Ошибка загрузки объекта';
            dispatch(setError(errorMessage));
        }
        dispatch(setLoading(false));
        return { success: false, error: axiosError.response?.data?.message };
    }
};


export const {
    setWarehouseObjects,
    setLoading,
    setError,
    setSuccessMessage,
    clearMessages,
} = warehouseObjectSlice.actions;

export default warehouseObjectSlice.reducer;