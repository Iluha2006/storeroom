import { createApi } from '@reduxjs/toolkit/query/react';

import { ICity, ICityResponse } from '@/types/city';

import { rtkBaseQuery } from './rtkBaseQuery';

export const cityApi = createApi({
  reducerPath: 'cityApi',
  baseQuery: rtkBaseQuery,
  tagTypes: ['City'],
  endpoints: (builder) => ({
    getCities: builder.query<ICity[], void>({
      query: () => '/api/cities',
      transformResponse: (response: unknown) => (response as ICityResponse ).data,
      providesTags: ['City'],
    }),
    getCityBySlug: builder.query<ICity, string>({
      query: (slug) => `/api/city/${slug}`,
      transformResponse: (response: unknown) => {
        const cityResponse = response as ICityResponse;
        return cityResponse.data as ICity;
      },
      providesTags: (_result, _error, slug) => [{ type: 'City', id: slug }],
    }),
  }),
});

export const { useGetCitiesQuery, useGetCityBySlugQuery } = cityApi;