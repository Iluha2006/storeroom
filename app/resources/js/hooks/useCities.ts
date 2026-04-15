import { useCallback } from 'react';

import { useGetCitiesQuery } from '../api/cityApi';

export const useCities = () => {
  const { data: cities = [], error, isLoading, refetch } = useGetCitiesQuery();

  const loadCities = useCallback(() => {
    refetch();
  }, [refetch]);

  return {
    cities,
    isLoading,
    error,
    loadCities,
  };
};