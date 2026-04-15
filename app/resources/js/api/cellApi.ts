import { createApi } from '@reduxjs/toolkit/query/react';

import { ICell } from '@/types/Cell';

import type { ApiResponse } from './interfaces/common';
import { rtkBaseQuery } from './rtkBaseQuery';

export const cellApi = createApi({
  reducerPath: 'cellApi',
  baseQuery: rtkBaseQuery,
  tagTypes: ['Cell'],
  endpoints: (builder) => ({
    getAllCells: builder.query<ICell[], void>({
      query: () => '/cells/all',
      transformResponse: (response: ApiResponse<ICell[]>) => response.data,
      providesTags: ['Cell'],
    }),
    getCellsByCitySlug: builder.query<ICell[], string>({
      query: (citySlug) => `/api/city/${citySlug}/cells`,
      transformResponse: (response: ApiResponse<ICell[]>) => response.data,
      providesTags: ['Cell'],
    }),
    getCellDetail: builder.query<ICell, string>({
      query: (cellSlug) => `/cellObject/${cellSlug}`,
      transformResponse: (response: ApiResponse<ICell>) => response.data,
      providesTags: (_result, _error, cellSlug) => [{ type: 'Cell', id: cellSlug }],
    }),
  }),
});

export const {
  useGetAllCellsQuery,
  useGetCellsByCitySlugQuery,
  useGetCellDetailQuery,
  useLazyGetCellDetailQuery,
} = cellApi;