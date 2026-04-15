import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';

export default function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const navigate = useNavigate();

  const navigateHome = () => {
    navigate('/');
  };

  const navigateAuth = () => {
    navigate('/register');
  };

  return (
    <header className="bg-white border-b border-gray-200 sticky top-0 z-50">
      <div className="mx-auto px-4 py-3 max-w-[420px] sm:max-w-6xl">


        <div className="hidden sm:flex  items-center justify-between">

          <div onClick={navigateHome} className=" flex gap-1 cursor-pointer items-center">

          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>
            <h1 className="text-xl font-bold text-gray-900">СкладХранение</h1>
          </div>


          <nav className="flex justify-center gap-6">
            <Link to="/city/cells/map" className="text-gray-700 hover:text-emerald-600 font-medium">
              Города
            </Link>
            <Link to="/" className="text-gray-700 hover:text-emerald-600 font-medium">
              Главная
            </Link>
            <a href="#" className="text-gray-700 hover:text-emerald-600 font-medium">
              FAQ
            </a>
          </nav>


          <button
            onClick={navigateAuth}
            className="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-colors duration-200"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="18"
              height="18"
              fill="currentColor"
              className="bi bi-person-circle"
              viewBox="0 0 16 16"
            >
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
              <path
                fillRule="evenodd"
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"
              />
            </svg>
            Войти
          </button>
        </div>


        <div className="sm:hidden flex items-center justify-between">

          <div onClick={navigateHome} className="cursor-pointer flex gap-1 cursor-pointer items-center">

          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>
            <h1 className="text-lg font-bold text-gray-900">СкладХранение</h1>
          </div>


          <div className="flex items-center gap-4">
            <button
              onClick={navigateAuth}
              className="text-gray-700 hover:text-emerald-600"
              aria-label="Войти"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="currentColor"
                className="bi bi-person-circle"
                viewBox="0 0 16 16"
              >
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path
                  fillRule="evenodd"
                  d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"
                />
              </svg>
            </button>

            <button
              className="text-gray-700 focus:outline-none"
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              aria-label="Меню"
            >
              {isMenuOpen ? (
                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              )}
            </button>
          </div>
        </div>

        {/* Mobile menu */}
        {isMenuOpen && (
          <nav className="sm:hidden mt-4 pb-4 space-y-3">
            <Link
              to="/city/cells/map"
              className="block text-gray-700 hover:text-emerald-600 font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Города
            </Link>
            <Link
              to="/"
              className="block text-gray-700 hover:text-emerald-600 font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              Главная
            </Link>
            <a
              href="#"
              className="block text-gray-700 hover:text-emerald-600 font-medium py-2"
              onClick={() => setIsMenuOpen(false)}
            >
              FAQ
            </a>
          </nav>
        )}
      </div>
    </header>
  );
}
