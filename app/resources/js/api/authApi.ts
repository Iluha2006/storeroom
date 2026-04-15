import { createApi } from '@reduxjs/toolkit/query/react';

import type {
  CheckVerificationResponse,
  LoginRequest,
  LoginResponse,
  LogoutResponse,
  RegisterRequest,
  RegisterResponse,
  ResendVerificationRequest,
  ResendVerificationResponse,
} from './interfaces/auth';
import { rtkBaseQuery } from './rtkBaseQuery';

export const authApi = createApi({
  reducerPath: 'authApi',
  baseQuery: rtkBaseQuery,
  tagTypes: ['Auth'],
  endpoints: (builder) => ({
    login: builder.mutation<LoginResponse, LoginRequest>({
      query: (body) => ({
        url: '/auth/login',
        method: 'POST',
        body,
      }),
      invalidatesTags: ['Auth'],
    }),
    register: builder.mutation<RegisterResponse, RegisterRequest>({
      query: (body) => ({
        url: '/auth/register',
        method: 'POST',
        body,
      }),
    }),
    logout: builder.mutation<LogoutResponse, void>({
      query: () => ({
        url: '/auth/logout',
        method: 'POST',
      }),
      invalidatesTags: ['Auth'],
    }),
    checkVerification: builder.query<CheckVerificationResponse, void>({
      query: () => '/auth/check-verification',
      providesTags: ['Auth'],
    }),
    resendVerificationEmail: builder.mutation<
      ResendVerificationResponse,
      ResendVerificationRequest
    >({
      query: (body) => ({
        url: '/email/resend',
        method: 'POST',
        body,
      }),
    }),
  }),
});

export const {
  useLoginMutation,
  useRegisterMutation,
  useLogoutMutation,
  useLazyCheckVerificationQuery,
  useResendVerificationEmailMutation,
} = authApi;

