
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { RegisterButton } from '@/UI/Button/Auth/Registered';

import { useAuth } from '../../hooks/useAuth';
import SuccessNotification from '../Notification/Notification';

import { Error } from './ErrorAuth';


export default function RegisterForm() {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  const navigate = useNavigate();
  const [notification, setNotification] = useState(false);
  const { register,  isLoading } = useAuth();
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const reg = await register(formData);
    if (reg?.success) {
      setNotification(true);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <div>
          <h2 className="mt-6 text-center text-3xl font-extrabold text-gray-900">
           Регистрация
          </h2>

        </div>

        <Error/>

        {notification && (
          <SuccessNotification message="Проверьте вашу почту для подтверждения регистрации" />
        )}


        <form className="mt-8 space-y-6" onSubmit={handleSubmit}>
          <div className="space-y-4">
            <div>
              <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">
                Имя
              </label>
              <input
                id="name"
                name="name"
                type="text"
                autoComplete="name"
                required
                value={formData.name}
                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                className="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 text-sm transition-colors"
                placeholder="Введите ваше имя"
              />
            </div>

            <div>
              <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                Email
              </label>
              <input
                id="email"
                name="email"
                type="email"
                autoComplete="email"
                required
                value={formData.email}
                onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                className="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 text-sm transition-colors"
                placeholder="example@mail.com"
              />
            </div>

            <div>
              <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-1">
                Пароль
              </label>
              <input
                id="password"
                name="password"
                type="password"
                autoComplete="new-password"
                required
                value={formData.password}
                onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                className="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 text-sm transition-colors"
                placeholder="Минимум 8 символов"
              />
            </div>

            <div>
              <label htmlFor="password_confirmation" className="block text-sm font-medium text-gray-700 mb-1">
                Подтверждение пароля
              </label>
              <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autoComplete="new-password"
                required
                value={formData.password_confirmation}
                onChange={(e) => setFormData({ ...formData, password_confirmation: e.target.value })}
                className="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 text-sm transition-colors"
                placeholder="Повторите пароль"
              />
            </div>
          </div>

          <div>
          <RegisterButton isLoading={isLoading} />
          </div>

          <div className="text-center pt-4 border-t border-gray-200">
          <p className="text-sm text-gray-600">
              Не получили письмо?{' '}
              <button
                type="button"
                onClick={() => navigate('/resend-verification')}
                className="font-medium text-emerald-600 hover:text-emerald-700 hover:underline transition-colors bg-transparent border-none p-0 cursor-pointer"
              >
                Отправить повторно
              </button>
            </p>

            <p className="text-sm text-gray-600">
              Уже есть аккаунт?{' '}
              <a
                 onClick={()=> navigate ('/login')}
                className="font-medium text-emerald-600 hover:text-emerald-500 transition-colors"
              >
                Войти
              </a>
            </p>
          </div>
        </form>
      </div>
    </div>
  );
}
