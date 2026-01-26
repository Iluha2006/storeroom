<<<<<<< HEAD
// components/CityList.tsx
import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

import { ICity } from '@/types/city';

import { useCities } from '../hooks/useCities';
import { useWarehouseObjects } from '../hooks/useWarehouseObjects';

=======

import React, { useEffect } from 'react';

import { useCities } from '../hooks/useCities';
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c

const CityList: React.FC = () => {
  const {
    cities,
<<<<<<< HEAD
    loading: citiesLoading,
    loadCities,
  } = useCities();

  const {
    objects,
    getObjectsCountByCityId,
  } = useWarehouseObjects();


  const [citiesWithCount, setCitiesWithCount] = useState<Array<ICity & { objectsCount: number }>>([]);

=======
    loading,
    error,
    successMessage,
    loadCities,
  } = useCities();

>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
  useEffect(() => {
    loadCities();
  }, [loadCities]);

<<<<<<< HEAD

  useEffect(() => {
    if (cities.length > 0) {
      const citiesWithObjectsCount = cities.map(city => ({
        ...city,
        objectsCount: getObjectsCountByCityId(city.id)
      }));
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setCitiesWithCount(citiesWithObjectsCount);
    }
  }, [cities, objects, getObjectsCountByCityId]);

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
        {citiesWithCount.map((city) => (
          <Link
            key={city.uuid}
            to={`/city/${city.slug}`}
            className="block p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-200"
          >
            <div className="flex justify-between items-start">
              <h3 className="text-xl font-semibold text-gray-800 mb-2">
                {city.name}
              </h3>
              {city.objectsCount > 0 ? (
                <span className="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                  {city.objectsCount}
                </span>
              ) : (
                <span className="text-sm font-medium text-gray-400 bg-gray-100 px-3 py-1 rounded-full">
                  Нет объектов
                </span>
              )}
            </div>
          </Link>
        ))}
      </div>


=======
  if (loading && cities.length === 0) {
    return <div>Загрузка городов...</div>;
  }

  if (error) {
    return <div className="error">{error}</div>;
  }

  return (
    <div>
      {successMessage && <div className="success">{successMessage}</div>}

      <h1>Список городов ({cities.length})</h1>
      <div className="cities-grid">
        {cities.map((city) => (
          <div key={city.uuid} className="city-card">
            <h3>{city.name}</h3>
            <p>Slug: {city.slug}</p>
          </div>
        ))}
      </div>
      {loading && cities.length > 0 && <div>Обновление данных...</div>}
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
    </div>
  );
};

export default CityList;