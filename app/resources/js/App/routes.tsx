// AppRoutes.tsx
import { Routes, Route } from 'react-router-dom';



import CityCells from '@/components/WarehouseObject';
import CellDetailPage from '@/pages/Cell/CellDetailPage';
import Maps from '@/pages/MapCity/MapPage';

import Layout from '../_layout/Layout';
import CityPage from '../pages/Citys/CityPage';
import NotFound from '../pages/Errors/NotFound';
import HomePage from '../pages/home/HomePage';
const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/city" element={<Layout><CityPage /></Layout>} />
      <Route path="/cellObject/:citySlug" element={<CellDetailPage />} />
      <Route path="/city/:citySlug" element={<CityCells/>} />
      <Route path="/city/map/:citySlug" element={<Maps/>} />
      <Route path="*" element={<Layout><NotFound /></Layout>} />
    </Routes>
  );
};

export default AppRoutes;