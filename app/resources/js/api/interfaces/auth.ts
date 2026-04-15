import type { IUser } from '@/types/User';

export type ApiSuccess<T> = {
  success: true;
  message: string;
  data: T;
};

export type ApiFailure = {
  success: false;
  message: string;
  errors?: unknown;
};

export type LoginRequest = { email: string; password: string };

export type LoginResponse = ApiSuccess<{
  user: IUser;
  token: string;
  token_type: 'Bearer' | string;
}>;

export type RegisterRequest = {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
};

export type RegisterResponse = ApiSuccess<{
  user: IUser;
  requires_verification: boolean;
}>;

export type LogoutResponse = ApiSuccess<null>;

export type CheckVerificationResponse = {
  success: boolean;
  verified: boolean;
  user?: Partial<IUser> & { email?: string; email_verified_at?: string | null };
  message?: string;
  redirect_to?: string | null;
};

export type ResendVerificationRequest = { email: string };

export type ResendVerificationResponse = { message: string };

