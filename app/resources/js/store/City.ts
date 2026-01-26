import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import axios, { AxiosError } from 'axios';

<<<<<<< HEAD
import { ICity } from '@/types/city';

import type { AppDispatch } from '../store/store';

interface ICityState {
    items: ICity[];
    currentCity: ICity | null;
    loading: boolean;
    error: string | null;
    successMessage: string | null;
}
=======
import {
    ICity,
    ICityState,
    ICitiesResponse,
    ICityResponse  } from '../types/city';

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

const initialState: ICityState = {
    items: [],
    currentCity: null,
<<<<<<< HEAD
=======
    selectedCity: null,
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    loading: false,
    error: null,
    successMessage: null
};

const citySlice = createSlice({
    name: 'cities',
    initialState,
    reducers: {
<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
        setCities: (state, action: PayloadAction<ICity[]>) => {
            state.items = action.payload;
        },
        setCurrentCity: (state, action: PayloadAction<ICity | null>) => {
            state.currentCity = action.payload;
        },
<<<<<<< HEAD
=======
        setSelectedCity: (state, action: PayloadAction<ICity | null>) => {
            state.selectedCity = action.payload;
        },
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
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
<<<<<<< HEAD
    }
});

export const fetchCities = () => async (dispatch: AppDispatch): Promise<{success: boolean; data?: ICity[]; error?: string}> => {
    try {
        dispatch(setLoading(true));

        const response = await axios.get('/api/city/list');
=======

    }
});


export const fetchCities = () => async (dispatch:any): Promise<{success: boolean; data?: ICity[]; error?: string}> => {
    try {
        dispatch(setLoading(true));

        const response = await axios.get<ICitiesResponse>('/api/city/list');
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

        if (response.data.success) {
            dispatch(setCities(response.data.data));
            dispatch(setLoading(false));
            return { success: true, data: response.data.data };
        } else {
            dispatch(setError(response.data.message || 'Ошибка загрузки городов'));
            dispatch(setLoading(false));
            return {
                success: false,
                error: response.data.message || 'Ошибка загрузки городов'
            };
        }
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;
        const errorMessage = axiosError.response?.data?.message ||
                            axiosError.response?.data?.error ||
                            'Ошибка загрузки городов';
<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
        dispatch(setError(errorMessage));
        dispatch(setLoading(false));
        return { success: false, error: errorMessage };
    }
};

<<<<<<< HEAD
export const fetchCityBySlug = (slug: string) => async (dispatch: AppDispatch): Promise<{success: boolean; data?: ICity; error?: string}> => {
    try {
        dispatch(setLoading(true));

        const response = await axios.get(`/api/city/${slug}`);
=======
export const fetchCityBySlug = (slug: string) => async (dispatch:any): Promise<{success: boolean; data?: ICity; error?: string}> => {
    try {
        dispatch(setLoading(true));


        const response = await axios.get<ICityResponse>(`/api/city/${slug}`);
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

        if (response.data.success) {
            const cityData = response.data.arrayData || response.data.data;

            if (cityData) {
                dispatch(setCurrentCity(cityData));
                dispatch(setLoading(false));
                return { success: true, data: cityData };
            } else {
                dispatch(setError('Данные города отсутствуют'));
                dispatch(setLoading(false));
                return { success: false, error: 'Данные города отсутствуют' };
            }
        } else {
            dispatch(setError(response.data.message || 'Город не найден'));
            dispatch(setLoading(false));
            return {
                success: false,
                error: response.data.message || 'Город не найден'
            };
        }
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;

        if (axiosError.response?.status === 404) {
            dispatch(setError('Город не найден'));
        } else {
            const errorMessage = axiosError.response?.data?.message ||
                                axiosError.response?.data?.error ||
                                'Ошибка загрузки города';
            dispatch(setError(errorMessage));
        }

        dispatch(setLoading(false));
        return {
            success: false,
            error: axiosError.response?.data?.message || 'Ошибка загрузки города'
        };
    }
};

<<<<<<< HEAD
export const {
    setCities,
    setCurrentCity,
    setLoading,
    setError,
    setSuccessMessage,
    clearMessages,
=======
export const fetchCityWithObjects = (citySlug: string) => async (dispatch: any): Promise<{success: boolean; city?: ICity; objects?: any; error?: string}> => {
    try {
        dispatch(setLoading(true));



        const cityResponse = await axios.get<ICityResponse>(`/api/city/${citySlug}`);

        if (!cityResponse.data.success) {
            dispatch(setError(cityResponse.data.message || 'Город не найден'));
            dispatch(setLoading(false));
            return {
                success: false,
                error: cityResponse.data.message || 'Город не найден'
            };
        }

        const cityData = cityResponse.data.arrayData || cityResponse.data.data;

        if (!cityData) {
            dispatch(setError('Данные города отсутствуют'));
            dispatch(setLoading(false));
            return { success: false, error: 'Данные города отсутствуют' };
        }

        dispatch(setCurrentCity(cityData));


        const objectsResponse = await axios.get(`/api/city/${citySlug}/available`);

        dispatch(setLoading(false));

        return {
            success: true,
            city: cityData,
            objects: objectsResponse.data
        };
    } catch (error) {
        const axiosError = error as AxiosError<{message?: string; error?: string}>;
        const errorMessage = axiosError.response?.data?.message ||
                            'Ошибка загрузки данных города';

        dispatch(setError(errorMessage));
        dispatch(setLoading(false));

        return {
            success: false,
            error: errorMessage
        };
    }
};


export const {
    setCities,
    setCurrentCity,
    setSelectedCity,
    setLoading,
    setError,
    setSuccessMessage,

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
} = citySlice.actions;

export default citySlice.reducer;