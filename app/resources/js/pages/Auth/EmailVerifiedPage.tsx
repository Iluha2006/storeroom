
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { useAppDispatch } from '@/hooks/useAppDispatch';

import { useAuth } from '../../hooks/useAuth';

export default function EmailVerifiedPage() {

    const {checkAuthStatus }=useAuth()
  const navigate = useNavigate();
  const dispatch = useAppDispatch();

  useEffect(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('verified') === 'true') {
      checkAuthStatus();
    }
  }, [dispatch]);

  return (
    <div className="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md text-center">
      <h2 className="text-2xl font-bold text-green-600 mb-4">✅ Email подтверждён!</h2>
      <p className="text-gray-700 mb-6">Теперь вы можете войти в свой аккаунт.</p>
      <button
        onClick={() => navigate('/login')}
        className="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-6 rounded"
      >
        Войти
      </button>
    </div>
  );
}