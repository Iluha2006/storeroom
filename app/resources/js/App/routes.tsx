import { Routes, Route } from 'react-router-dom';


import InfoRental from '@/components/CellRental/CellRental';
import ResendVerificationPage from '@/pages/Auth/ResendVerificationPage';

import Layout from '../_layout/Layout';
import CityCells from '../components/Object/WarehouseObject';
import EmailVerifiedPage from '../pages/Auth/EmailVerifiedPage';
import LoginPage from '../pages/Auth/LoginPage';
import RegisterPage from '../pages/Auth/RegisterPage';
import CellDetailPage from '../pages/Cell/CellDetailPage';
import CityPage from '../pages/Citys/CityPage';
import NotFound from '../pages/Errors/NotFound';
import HomePage from '../pages/home/HomePage';
import Maps from '../pages/MapCity/MapPage';


const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/city" element={<Layout><CityPage /></Layout>} />
      <Route path="/register" element={<Layout><RegisterPage/></Layout>} />
      <Route path="/resend-verification" element={<Layout> <ResendVerificationPage /></Layout>} />
      <Route path="/login" element={<Layout><LoginPage/></Layout>} />
      <Route path="/email-verified" element={<Layout><EmailVerifiedPage /> </Layout> } />
      <Route path="/cell/:cellSlug/rent" element={<Layout><InfoRental /> </Layout>} />
      <Route path="/cellObject/:cellSlug" element={<CellDetailPage />} />
      <Route path="/city/:citySlug" element={<CityCells/>} />
      <Route path="/city/cells/map" element={<Maps/>} />
      <Route path="*" element={<Layout><NotFound /></Layout>} />
    </Routes>
  );
};

export default AppRoutes;
