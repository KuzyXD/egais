export const formatYmd = (date) => date.toISOString().slice(0, 10);
export const getSortableState = (colObject) => {
    return colObject.sortableState === 'asc' || colObject.sortableState === 'desc'
};
