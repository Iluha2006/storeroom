import { Routes, Route } from 'react-router-dom';
import Home from '../pages/home/Home';
import NotFound from '../pages/Errors/NotFound';

const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  );
};

export default AppRoutes;