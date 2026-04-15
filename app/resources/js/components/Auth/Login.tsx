import { useState, useEffect } from 'react';
import { useNavigate, Link } from 'react-router-dom';

import { clearError } from '@/store/Auth';
import { useAppDispatch } from '@/hooks/useAppDispatch';

import { useAuth } from '../../hooks/useAuth';
import AuthErrorNotification from '../Notification/AuthErrorNotification';

export default function LoginForm() {
  const [formData, setFormData] = useState({ email: '', password: '' });
  const { login, error, isLoading } = useAuth();
  const dispatch = useAppDispatch();
  const navigate = useNavigate();

  useEffect(() => {
    dispatch(clearError());
  }, [dispatch]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const result = await login(formData);
    if (result?.success) {
      navigate('/');
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
      <div className="max-w-md w-full bg-white p-8 rounded-lg shadow-md border border-gray-200">
        <h2 className="text-3xl font-bold text-gray-900 text-center mb-8">Вход </h2>
        {error && (
          <AuthErrorNotification
            error={error}
            email={formData.email}
            resendPath="/resend-verification"
            resendLinkText="Отправить письмо подтверждения повторно?"
            verificationKeyword="подтвердите"
          />
        )}
        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              type="email"
              required
              value={formData.email}
              onChange={(e) => setFormData({ ...formData, email: e.target.value })}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"
              placeholder="example@mail.com"
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1">Пароль</label>
            <input
              type="password"
              required
              value={formData.password}
              onChange={(e) => setFormData({ ...formData, password: e.target.value })}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"

            />
          </div>
          <button
            type="submit"
            disabled={isLoading}
            className="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white font-medium rounded-lg transition-colors"
          >
            {isLoading ? 'Вход...' : 'Войти'}
          </button>
        </form>

        <div className="mt-6 text-center">
          <Link to="/register" className="text-emerald-600 hover:underline text-sm">
            Нет аккаунта? Зарегистрироваться
          </Link>
        </div>
      </div>
    </div>
  );
}