

export default function Header( ){


    return(

        <header className="bg-white border-b border-gray-200">
        <div className="container mx-auto px-4 py-4">
          <div className="flex flex-col md:flex-row md:items-center justify-between">
            <div className="mb-4 md:mb-0">
              <h1 className="text-2xl font-bold text-gray-900">СкладХранение</h1>
            </div>
            <nav className="flex space-x-6">
              <a href="#" className="text-gray-700 hover:text-blue-600 font-medium">Главная</a>
              <a href="#" className="text-gray-700 hover:text-blue-600 font-medium">Города</a>
              <a href="#" className="text-gray-700 hover:text-blue-600 font-medium">FAQ</a>
            </nav>
          </div>
        </div>
      </header>
   
    )
}