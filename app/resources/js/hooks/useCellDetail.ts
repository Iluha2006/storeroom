import { useCallback } from 'react';

import { useLazyGetCellDetailQuery } from '@/api/cellApi';

export const useCellDetail = () => {
  const [trigger, { data: cell, isLoading, isFetching, error }] = useLazyGetCellDetailQuery();

  const loadCell = useCallback(
    (slug: string) => {
      return trigger(slug).unwrap();
    },
    [trigger]
  );

  return { cell, loading: isLoading || isFetching, error, loadCell };
};

