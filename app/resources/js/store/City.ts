import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import axios, { AxiosError } from 'axios';

import { ICity } from '@/types/city';

import type { AppDispatch } from '../store/store';


interface ICityState {
    items: ICity[];
    currentCity: ICity | null;
    selectedCity: ICity | null;
    loading: boolean;
    error: string | null;
    successMessage: string | null;
}


interface ICitiesResponse {
    success: boolean;
    data: ICity[];
    message?: string;
}



const initialState: ICityState = {
    items: [],
    currentCity: null,
    selectedCity: null,
    loading: false,
    error: null,
    successMessage: null
};

const citySlice = createSlice({
    name: 'cities',
    initialState,
    reducers: {
        setCities: (state, action: PayloadAction<ICity[]>) => {
            state.items = action.payload;
        },
        setCurrentCity: (state, action: PayloadAction<ICity | null>) => {
            state.currentCity = action.payload;
        },
        setSelectedCity: (state, action: PayloadAction<ICity | null>) => {
            state.selectedCity = action.payload;
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
        }
    }
});


export const fetchCities = () => async (dispatch: AppDispatch): Promise<{success: boolean; data?: ICity[]; error?: string}> => {
    try {
        dispatch(setLoading(true));
        dispatch(clearMessages());

        const response = await axios.get<ICitiesResponse>('/api/cities');

        if (response.data.success) {
            dispatch(setCities(response.data.data));
            dispatch(setLoading(false));
            return { success: true, data: response.data.data };
        } else {
            const errorMessage = response.data.message || 'Ошибка загрузки городов';
            dispatch(setError(errorMessage));
            dispatch(setLoading(false));
            return {
                success: false,
                error: errorMessage
            };
        }
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;
        const errorMessage = axiosError.response?.data?.message ||
                            axiosError.response?.data?.error ||
                            'Ошибка загрузки городов';

        dispatch(setError(errorMessage));
        dispatch(setLoading(false));
        return { success: false, error: errorMessage };
    }
};


export const fetchIdCity = () => async (dispatch: AppDispatch, citySlug: string): Promise<{success: boolean; data?: ICity[]; error?: string}> => {

    const response = await axios.get<ICitiesResponse>(`/api/city/${citySlug}`);

    if(response.data.success){
        dispatch(setCities(response.data.data))
        return { success:true, data: response.data.data}
    }
    else{
        return { success:false }
    }
};

export const {
    setCities,
    setCurrentCity,
    setSelectedCity,
    setLoading,
    setError,
    setSuccessMessage,
    clearMessages,
} = citySlice.actions;


export default citySlice.reducer;