import { createSlice, PayloadAction } from '@reduxjs/toolkit';

import { IUser } from '@/types/User';

interface AuthState {
  user: IUser | null;
  isAuthenticated: boolean;
  isEmailVerified: boolean,
  isLoading: boolean;
  error: string | null;
}

const initialState: AuthState = {
  user: null,
  isAuthenticated: false,
  isEmailVerified: false,
  isLoading: false,
  error: null,
};

const authSlice = createSlice({
  name: 'auth',
  initialState,
  reducers: {
    setLoading: (state, action: PayloadAction<boolean>) => {
      state.isLoading = action.payload;
    },
    setUser: (state, action: PayloadAction<IUser | null>) => {
      state.user = action.payload;
      state.isAuthenticated = !!action.payload;
      state.error = null;
    },
    setError: (state, action: PayloadAction<string | null>) => {
      state.error = action.payload;
      state.isLoading = false;
    },

    clearAuth: (state) => {
        state.user = null;
        state.isAuthenticated = false;
        state.isEmailVerified = false;
        state.error = null;
      },
      clearError: (state) => {
        state.error = null;
      },

      setEmailVerified: (state, action: PayloadAction<boolean>) => {
        state.isEmailVerified = action.payload;
      },
  },
});

export const { setLoading, setUser, setError, clearAuth ,setEmailVerified, clearError} = authSlice.actions;

export default authSlice.reducer;