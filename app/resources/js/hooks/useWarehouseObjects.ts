
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { AppDispatch, RootState } from '../store/store';
import {
  fetchWarehouseObjectsByCity,
  fetchWarehouseObjectBySlug,
} from '../store/warehouseObject';

export const useWarehouseObjects = () => {
  const dispatch = useDispatch<AppDispatch>();
  const { objects, loading, error, successMessage } = useSelector(
    (state: RootState) => state.warehouseObjects
  );

  const loadObjectsByCity = useCallback(
    async (citySlug: string) => {
      return await dispatch(fetchWarehouseObjectsByCity(citySlug));
    },
    [dispatch]
  );

  const loadObjectBySlug = useCallback(
    async (citySlug: string, objectSlug: string) => {
      return await dispatch(fetchWarehouseObjectBySlug(citySlug, objectSlug));
    },[dispatch]
  );

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