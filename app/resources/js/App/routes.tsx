import { Routes, Route } from 'react-router-dom';

import CityPage from '../pages/Citys/CityPage';
import NotFound from '../pages/Errors/NotFound';
import HomePage from '../pages/home/HomePage';



const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/" element={<CityPage />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default AppRoutes;