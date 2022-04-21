function middlewarePipeline (context, middleware, index) {
    const nextMiddleware = middleware[index]

    if(!nextMiddleware){
        return context.next
    }

    return param => {
        if (param) return context.next(param)

        const nextPipeline = middlewarePipeline(
            context, middleware, index + 1
        )

        nextMiddleware({ ...context, next: nextPipeline })
    }
}

export default middlewarePipeline
