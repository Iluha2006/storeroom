<<<<<<< HEAD
=======

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { Provider } from 'react-redux';
import { BrowserRouter } from 'react-router-dom';

<<<<<<< HEAD
import App from './App/App';
=======
import App from './App/app';
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
import { store } from './store/store';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <Provider store={store}>
      <BrowserRouter>
        <App />
      </BrowserRouter>
    </Provider>
  </StrictMode>
<<<<<<< HEAD
);
=======
);
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
