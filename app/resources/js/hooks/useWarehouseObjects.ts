
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import {
  fetchWarehouseObjectsByCity,
  fetchWarehouseObjectBySlug,
} from '../store/warehouseObject';
import { AppDispatch, RootState } from '../store/store';

export const useWarehouseObjects = () => {
  const dispatch = useDispatch<AppDispatch>();
  const { objects, loading, error, successMessage } = useSelector(
    (state: RootState) => state.warehouseObjects
  );

  // Загрузка объектов по городу
  const loadObjectsByCity = useCallback(
    async (citySlug: string) => {
      return await dispatch(fetchWarehouseObjectsByCity(citySlug));
    },
    [dispatch]
  );

  // Загрузка конкретного объекта
  const loadObjectBySlug = useCallback(
    async (citySlug: string, objectSlug: string) => {
      return await dispatch(fetchWarehouseObjectBySlug(citySlug, objectSlug));
    },
    [dispatch]
  );

  // Получить количество объектов для города
  const getObjectsCountByCityId = useCallback(
    (cityId: number) => {
      return objects.filter(obj => obj.address?.city_id === cityId).length;
    },
    [objects]
  );

  return {
    objects,
    loading,
    error,
    successMessage,
    loadObjectsByCity,
    loadObjectBySlug,
    getObjectsCountByCityId,
  };
};