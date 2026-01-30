
import React, { useEffect,useState } from 'react';
import { useParams, Link } from 'react-router-dom';

import Layout from '@/_layout/Layout';

import { useCells } from '../hooks/useCells';

import MapCityPosition from './MapCity';

const CellDetail = () => {
    const { cellSlug } = useParams<{ cellSlug: string }>();
    const { cells, loading, CellsByShow } = useCells();
    const [showMap, setShowMap] = useState(false);
    useEffect(() => {
        if (cellSlug) {
            CellsByShow(cellSlug);
        }

    }, [cellSlug, CellsByShow]);

    useEffect(() => {
        if (cells.length > 0) {
          const cell = cells[0];
          console.log('Данные ячейки:', cell);
          console.log('Координаты:', cell.object?.address?.lat, cell.object?.address?.lon);
        }
      }, [cells]);

    if (loading) {
        return (
            <Layout>
                <div className="flex justify-center items-center min-h-screen">
                    <div className="text-lg">Загрузка...</div>
                </div>
            </Layout>
        );
    }

    if (!cells || cells.length === 0) {
        return (
            <Layout>
                <div className="max-w-7xl mx-auto px-4 py-8 text-center">
                    <h2 className="text-2xl font-bold text-gray-900 mb-4">Ячейка не найдена</h2>
                    <Link to="/city" className="text-emerald-600 hover:text-emerald-800">
                        Вернуться к выбору города
                    </Link>
                </div>
            </Layout>
        );
    }


    const cell = cells[0]

    return (
        <Layout>
            <div className="max-w-4xl mx-auto px-4 py-8">
                <nav className="flex items-center space-x-2 text-sm text-gray-600 mb-6">

                    <Link to="/" className="hover:text-emerald-600">Главная</Link>
                    <span>/</span>
                    <Link to="/city" className="hover:text-emerald-600">Города</Link>
                    <span>/</span>
                    <Link
                        to={`/city/${cell.object?.address?.city?.slug}`}
                        className="hover:text-emerald-600"
                    >
                        {cell.object?.address?.city?.name}
                    </Link>
                    <span>/</span>
                    <span className="text-gray-900 font-medium">Ячейка {cell.slug}</span>
                </nav>

                <div className="bg-white rounded-xl shadow-sm p-6 mb-6">
                <button
            onClick={() => setShowMap(!showMap)}
            className="inline-flex items-center px-4 py-2 mb-4 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors"
          >
            {showMap ? 'Скрыть карту' : 'Посмотреть на карте'}
          </button>
                    <button
                        className="inline-flex items-center px-2 py-2
             bg-emerald-400 hover:bg-emerald-600 text-white text-lg font-medium rounded-lg transition-colors">Посмотреть на карте </button>
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        {cell.object?.name}
                    </h1>
                    <p className="text-gray-600 mb-4">
                        {cell.object?.address?.full_address}
                    </p>
                    <div className="flex items-center gap-4 text-lg">
                        <span className="font-semibold text-emerald-600">
                            {Number(cell.price.amount)} ₽/мес
                        </span>

                    </div>
                </div>
                {showMap && <MapCityPosition cell={cell} />}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div className="bg-gray-50 rounded-lg p-6">
                        <h3 className="text-xl font-semibold text-gray-900 mb-4">Размеры</h3>
                        <div className="space-y-3">
                            <div className="flex justify-between">
                                <span className="text-gray-600">Ширина:</span>
                                <span className="font-medium">{cell.dimensions.width} м</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Высота:</span>
                                <span className="font-medium">{cell.dimensions.height} м</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Глубина:</span>
                                <span className="font-medium">{cell.dimensions.length} м</span>
                            </div>
                            <div className="flex justify-between pt-2 border-t">
                                <span className="font-semibold text-gray-900">Объем:</span>
                                <span className="font-bold">{cell.dimensions.volume} м³</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-gray-50 rounded-lg p-6">
                        <h3 className="text-xl font-semibold text-gray-900 mb-4">Позиция</h3>
                        <div className="space-y-3">
                            <div className="flex justify-between">
                                <span className="text-gray-600">Этаж:</span>
                                <span className="font-medium">{cell.position.floor}</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Ряд:</span>
                                <span className="font-medium">{cell.position.row}</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Секция:</span>
                                <span className="font-medium">{cell.position.section}</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">Уровень:</span>
                                <span className="font-medium">{cell.position.level}</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-gray-600">№ ячейки:</span>
                                <span className="font-medium">{cell.position.number}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white rounded-xl shadow-sm p-6">
                    <h3 className="text-xl font-semibold text-gray-900 mb-4">Как добраться</h3>
                    <div className="prose prose-gray max-w-none">
                        <p>{cell.how_to_get_there}</p>
                    </div>
                </div>

                <div className="mt-8 flex justify-center">
                    <Link
                        to={`/city/${cell.object?.address?.city?.slug}`}
                        className="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-lg font-medium rounded-lg transition-colors"
                    >
                        Назад к городу
                    </Link>
                </div>
            </div>
        </Layout>
    );
};

export default CellDetail;