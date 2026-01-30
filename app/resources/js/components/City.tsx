import React, { useEffect} from 'react';
import { Link } from 'react-router-dom';

import { useCities } from '../hooks/useCities';


const CityList: React.FC = () => {

  const {
    cities,
    loading: citiesLoading,
    loadCities,

  } = useCities();



  useEffect(() => {
    loadCities();
  }, [loadCities]);



  if (citiesLoading && cities.length === 0) {
    return (
      <div className="flex justify-center items-center min-h-screen">
        <div className="text-lg">Загрузка городов...</div>
      </div>
    );
  }
  return (
    <div className="max-w-6xl mx-auto px-4 py-8">
      <div className="text-center mb-12">
        <h1 className="text-4xl font-bold text-gray-900 mb-4">
          Наши склады
        </h1>
        <p className="text-lg text-gray-600 max-w-2xl mx-auto">
          Выберите город и найдите удобное место для хранения ваших вещей
        </p>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
        {cities.map((city) => (
          <Link
            key={city.uuid}
            to={`/city/${city.slug}`}
            className="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-200"
          >
            <div className="flex justify-between items-start" >
              <h3 className="text-xl font-semibold text-gray-800 mb-2">
                {city.name}
              </h3>

            </div>
          </Link>

        ))}
      </div>
    </div>
  );
};

export default CityList;