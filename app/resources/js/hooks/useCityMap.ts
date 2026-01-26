
import { useCallback } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { AppDispatch, RootState } from '../store/store';
import {
    fetchWarehouseObjectsByCity,
    fetchWarehouseObjectBySlug,
} from '../store/warehouseObject';

export const useWarehouseObjects = () => {
    const dispatch = useDispatch<AppDispatch>();
    const {
        items: objects,
        currentObject,
        loading,
        error
    } = useSelector((state: RootState) => state.warehouseObjects);


    const loadObjectsByCity = useCallback(async (citySlug: string) => {
        return await dispatch(fetchWarehouseObjectsByCity(citySlug));
    }, [dispatch]);


    const loadObjectBySlug = useCallback(async (citySlug: string, objectSlug: string) => {
        return await dispatch(fetchWarehouseObjectBySlug(citySlug, objectSlug));
    }, [dispatch]);



    const getObjectAddress = useCallback((object: any): string => {
        if (!object?.address) return 'Адрес не указан';

        const parts = [];
        if (object.address.street) parts.push(object.address.street);
        if (object.address.house) parts.push(`д. ${object.address.house}`);
        if (object.address.building) parts.push(`стр. ${object.address.building}`);
        if (object.address.frame) parts.push(`корп. ${object.address.frame}`);

        return  'Адрес не указан';
    }, []);


        const findObjectBySlug = useCallback((slug: string) => {
        return objects.find(obj => obj.slug === slug);
    }, [objects]);

    return {

        objects,
        currentObject,
        loading,
        error,


        loadObjectsByCity,
        loadObjectBySlug,


        getObjectCoords,
        getObjectAddress,
        findObjectBySlug,


    };
};