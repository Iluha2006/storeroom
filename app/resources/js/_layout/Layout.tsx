// _layout/Layout.tsx
import { ReactNode } from 'react';

import Footer from './Footer';
import Header from './Header';
import Main from './Main';

interface LayoutProps {
  children?: ReactNode;
}

export default function Layout({ children }: LayoutProps) {
  return (
    <div className="min-h-screen bg-white flex flex-col">
      <Header />
      <main className="flex-grow">
        {children || <Main />}
      </main>
      <Footer />
    </div>
  );
}