import { useCallback, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';


import {
  fetchCities,
   fetchIdCity
} from '../store/City';
import { AppDispatch, RootState } from '../store/store';

export const useCities = () => {
  const dispatch = useDispatch<AppDispatch>();
  const { items: cities, loading, error, successMessage, currentCity } = useSelector(
    (state: RootState) => state.cities
  );

  useEffect(() => {
    if (cities.length === 0) {
      dispatch(fetchCities());
    }
  }, [dispatch]);




  const loadCities = useCallback(() => {
    dispatch(fetchCities());
  }, [dispatch]);

  return {
    cities,
    currentCity,
    loading,

    error,
    successMessage,
    loadCities,

  };
}