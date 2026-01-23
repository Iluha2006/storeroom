

export default function Header( ){


    return(


    <footer className="bg-gray-50 py-8 border-t border-gray-200">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center">
            <div className="mb-4 md:mb-0">
              <h3 className="text-xl font-bold text-gray-900">СкладХранение</h3>
              <p className="text-gray-600 mt-2">Безопасное хранение ваших вещей</p>
            </div>
            <div className="flex space-x-6">
              <a href="#" className="text-gray-600 hover:text-blue-600">Контакты</a>
              <a href="#" className="text-gray-600 hover:text-blue-600">Политика конфиденциальности</a>
              <a href="#" className="text-gray-600 hover:text-blue-600">Пользовательское соглашение</a>
            </div>
          </div>
          <div className="text-center mt-8 pt-8 border-t border-gray-300">
            <p className="text-gray-500">© 2024 СкладХранение. Все права защищены.</p>
          </div>
        </div>
      </footer>
    )
}