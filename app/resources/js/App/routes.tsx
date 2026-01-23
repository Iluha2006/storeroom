import { Routes, Route } from 'react-router-dom';

import HomePage from '@/pages/home/HomePage';

import NotFound from '../pages/Errors/NotFound';



const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default AppRoutes;