// src/pages/Auth/ResendVerificationPage.tsx
import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';

import { useAuth } from '../../hooks/useAuth';

import SuccessNotification from './Notification';

export default function ResendVerification() {
  const [email, setEmail] = useState('');
  const [notification, setNotification] = useState(false);
  const { resendVerification, isLoading, error } = useAuth();
  const navigate = useNavigate();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!email.trim()) {
      return error;
    }
    const result = await resendVerification(email);

    if(result){
        setNotification(true);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <div className="text-center">
          <h2 className="mt-4 text-2xl font-extrabold text-gray-900">
            Повторная отправка письма
          </h2>
          <p className="mt-2 text-sm text-gray-600">
            Введите email, на который нужно отправить подтверждение
          </p>
        </div>

 {notification && (
  <SuccessNotification message="Проверьте вашу почту для подтверждения регистрации" />
  )}

        <form onSubmit={handleSubmit} className="mt-8 space-y-6">
          <div>
            <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
              Email
            </label>
            <input
              id="email"
              name="email"
              type="email"
              autoComplete="email"
              required
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm transition-colors"
              placeholder="example@mail.com"
              disabled={isLoading}
            />
          </div>

          <div className="flex flex-col gap-3">
            <button
              type="submit"
              disabled={isLoading}
              className="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-400 text-white font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors"
            >
              {isLoading ? 'Отправка...' : 'Отправить письмо'}
            </button>

            <button
              type="button"
              onClick={() => navigate('/login')}
              className="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors"
            >
              Вернуться ко входу
            </button>
          </div>
        </form>

        <div className="text-center pt-4 border-t border-gray-200">
          <p className="text-sm text-gray-600">
            Вспомнили пароль?{' '}
            <Link
              to="/login"
              className="font-medium text-emerald-600 hover:text-emerald-700 hover:underline transition-colors"
            >
              Войти в аккаунт
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
}
