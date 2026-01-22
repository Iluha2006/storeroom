
 import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { StrictMode } from 'react';
import { Provider } from 'react-redux';
import { store } from './store/store';
import { BrowserRouter } from 'react-router-dom';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.tsx', { eager: true });
    return pages[`./pages/${name}.tsx`];
  },
  setup({ el, App, props }) {
    createRoot(el).render(
      <StrictMode>
        <Provider store={store}>
          <BrowserRouter>
            <App {...props} />
          </BrowserRouter>
        </Provider>
      </StrictMode>
    );
  },
});