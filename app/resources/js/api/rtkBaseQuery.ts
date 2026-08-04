import { fetchBaseQuery } from '@reduxjs/toolkit/query/react';

function getCookie(name: string): string | undefined {
  const match = document.cookie.match(new RegExp(`(?:^|; )${name}=([^;]*)`));
  return match?.[1];
}

export const rtkBaseQuery = fetchBaseQuery({
  baseUrl: 'http://localhost:8005',
  credentials: 'include',
  prepareHeaders: (headers) => {
    headers.set('Accept', 'application/json');
    const xsrfToken = getCookie('XSRF-TOKEN');
    if (xsrfToken) {
      headers.set('X-XSRF-TOKEN', decodeURIComponent(xsrfToken));
    }

    return headers;
  },
});

