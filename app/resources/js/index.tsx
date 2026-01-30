import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

import App from './App/App';
import { store } from './store/store';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>
);
