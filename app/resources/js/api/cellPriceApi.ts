import { createApi } from '@reduxjs/toolkit/query/react';

import { CellPriceResponse, Tariff } from '@/types/Tariff';

import { rtkBaseQuery } from './rtkBaseQuery';




export const cellPriceApi = createApi({
  reducerPath: 'cellPriceApi',
  baseQuery: rtkBaseQuery,
  endpoints: (builder) => ({
    getCellPrice: builder.query<Tariff[], string>({
      query: (slug) => `/cell/${slug}/price`,
      transformResponse: (response: CellPriceResponse) => {
        return Object.values(response.tariffs);
      },
    }),
  }),
});

export const { useGetCellPriceQuery } = cellPriceApi;