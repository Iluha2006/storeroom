
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';


import {
  useLazyCheckVerificationQuery,
  useLoginMutation,
  useLogoutMutation,
  useRegisterMutation,
  useResendVerificationEmailMutation,
} from '@/api/authApi';
import { clearAuth, clearError, setEmailVerified, setError, setUser } from '@/store/Auth';
import type { AppDispatch, RootState } from '@/store/store';

export const useAuth = () => {
  const dispatch = useDispatch<AppDispatch>();
  const navigate = useNavigate();
  const { user, isAuthenticated, error, isEmailVerified } = useSelector(
    (state: RootState) => state.auth
  );

  const [loginMutation, loginState] = useLoginMutation();
  const [registerMutation, registerState] = useRegisterMutation();
  const [logoutMutation, logoutState] = useLogoutMutation();
  const [resendMutation, resendState] = useResendVerificationEmailMutation();
  const [checkVerification, checkVerificationState] = useLazyCheckVerificationQuery();

  const loginWithRedirect = useCallback(
    async (credentials: { email: string; password: string }) => {
      dispatch(clearError());
      try {
        const response = await loginMutation(credentials).unwrap();
        dispatch(setUser(response.data.user));
        dispatch(setEmailVerified(true));
        navigate('/');
        return { success: true, token: response.data.token, user: response.data.user };
      } catch (e: unknown) {
        const message =
          (e as any)?.data?.message ||
          (e as any)?.error ||
          'Неверный email или пароль';
        dispatch(setError(message));
        return { success: false, error: message };
      }
    },
    [dispatch, loginMutation, navigate]
  );

  const registerWithRedirect = useCallback(
    async (userData: {
      name: string;
      email: string;
      password: string;
      password_confirmation: string;
    }) => {
      dispatch(clearError());
      try {
        const response = await registerMutation(userData).unwrap();
        return { success: true, data: response.data, message: response.message };
      } catch (e: unknown) {
        const message =
          (e as any)?.data?.message ||
          (e as any)?.data?.errors?.email?.[0] ||
          (e as any)?.data?.errors?.name?.[0] ||
          (e as any)?.error ||
          'Ошибка регистрации';
        dispatch(setError(message));
        return { success: false, error: message };
      }
    },
    [dispatch, registerMutation]
  );

  const resendVerification = useCallback(
    async (email: string) => {
      dispatch(clearError());
      try {
        const response = await resendMutation({ email }).unwrap();
        return { success: true, message: response.message };
      } catch (e: unknown) {
        const message =
          (e as any)?.data?.message ||
          (e as any)?.error ||
          'Ошибка отправки письма';
        dispatch(setError(message));
        return { success: false, error: message };
      }
    },
    [dispatch, resendMutation]
  );

  const logoutWithRedirect = useCallback(async () => {
    try {
      await logoutMutation().unwrap();
    } finally {
      dispatch(clearAuth());
      navigate('/login');
    }
  }, [dispatch, logoutMutation, navigate]);

  const checkAuthStatus = useCallback(async () => {
    try {
      const response = await checkVerification().unwrap();
      if (response.success && response.user) {
        const isVerified =
          response.verified === true || response.user.email_verified_at != null;
        dispatch(setEmailVerified(isVerified));
        return { success: true, isVerified, redirectTo: response.redirect_to };
      }
      return { success: false, isVerified: false };
    } catch (e: unknown) {
      return { success: false, isVerified: false };
    }
  }, [checkVerification, dispatch]);

  const isLoading =
    loginState.isLoading ||
    registerState.isLoading ||
    logoutState.isLoading ||
    resendState.isLoading ||
    checkVerificationState.isFetching;

  return {
    user,
    isAuthenticated,
    isEmailVerified,
    error,
    resendVerification,
    login: loginWithRedirect,
    register: registerWithRedirect,
    logout: logoutWithRedirect,
    checkAuthStatus,
    isLoading,
  };
};