
export default function NotFound() {
    return (
      <div className="flex items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900 p-4">
        <div className="text-center">
          <h1 className="text-6xl font-bold text-gray-800 dark:text-white mb-4">404</h1>
          <h2 className="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
            Страница не найдена
          </h2>
          <p className="text-gray-600 dark:text-gray-400 mb-6 max-w-md">
            Кажется, вы попали не туда. Такой страницы не существует или она была перемещена.
          </p>
          <a
            href="/"
            className="inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
          >
            Вернуться на главную
          </a>
        </div>
      </div>
    );
  }