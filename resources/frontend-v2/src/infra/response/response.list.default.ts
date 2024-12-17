export interface ResponseListDefault {
    status_code: number,
    links: {
        first: string,
        last: string,
        prev: string,
        self: string,
        next: string
    },
    page: {
        from: number,
        to: number,
        total: number,
        per_page: number,
        current_page: number
    },
    data: any,
    meta: any
}
