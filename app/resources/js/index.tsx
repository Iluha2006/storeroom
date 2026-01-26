import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

const App = () => <div>Hello from React</div>;

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <App />
  </StrictMode>
);
