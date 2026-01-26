// hooks/useCities.ts
<<<<<<< HEAD
import { useCallback, useEffect } from 'react';
=======
import { useCallback} from 'react';
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
import { useDispatch, useSelector } from 'react-redux';

import {
  fetchCities,
  fetchCityBySlug,
<<<<<<< HEAD
=======
  fetchCityWithObjects,
  clearCurrentCity,
  clearMessages,
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
} from '../store/City';
import { AppDispatch, RootState } from '../store/store';

export const useCities = () => {
  const dispatch = useDispatch<AppDispatch>();
  const { items: cities, loading, error, successMessage, currentCity } = useSelector(
    (state: RootState) => state.cities
  );

<<<<<<< HEAD
  // УБЕРИТЕ cities из зависимостей - иначе бесконечный цикл
  useEffect(() => {
    if (cities.length === 0) { // Загружаем только если нет городов
      dispatch(fetchCities());
    }
  }, [dispatch]); // Только dispatch
=======
  const loadCities = useCallback(async () => {
    return await dispatch(fetchCities());
  }, [dispatch]);
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

  const loadCityBySlug = useCallback(
    async (slug: string) => {
      return await dispatch(fetchCityBySlug(slug));
    },
    [dispatch]
  );

<<<<<<< HEAD
  // Функция для принудительной перезагрузки
  const loadCities = useCallback(() => {
    dispatch(fetchCities());
=======
  const loadCityWithObjects = useCallback(
    async (slug: string) => {
      return await dispatch(fetchCityWithObjects(slug));
    },
    [dispatch]
  );

  const resetCurrentCity = useCallback(() => {
    dispatch(clearCurrentCity());
  }, [dispatch]);

  const clearAllMessages = useCallback(() => {
    dispatch(clearMessages());
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
  }, [dispatch]);

  return {
    cities,
    currentCity,
    loading,
    error,
    successMessage,
<<<<<<< HEAD
    loadCities, // Добавьте эту функцию
    loadCityBySlug,
=======
    loadCities,
    loadCityBySlug,
    loadCityWithObjects,
    resetCurrentCity,
    clearAllMessages,
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
  };
};