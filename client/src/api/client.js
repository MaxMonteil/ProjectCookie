const localStorageKey = process.env.VUE_APP_JWT_STORAGE_KEY

export async function client (endpoint, { body, ...customConfig } = {}) {
  const token = window.localStorage.getItem(localStorageKey)

  const headers = { 'content-type': 'application/json' }

  if (token) {
    headers.Authorization = `Bearer ${token}`
  }

  const config = {
    method: body ? 'POST' : 'GET',
    ...customConfig,
    headers: {
      ...headers,
      ...customConfig.headers,
    },
  }

  if (body) {
    config.body = JSON.stringify(body)
  }

  return window
    .fetch(process.env.VUE_APP_API_URL + '/' + endpoint, config)
    .then(async response => {
      if (response.status === 401) {
        logout()
        window.location.assign(window.location)
        return
      }

      const text = await response.text()
      const data = text && JSON.parse(text)

      if (!response.ok) {
        const error = (data && data.message) || response.statusText
        return Promise.reject(error)
      }

      return data
    })
}

function logout () {
  window.localStorage.removeItem(localStorageKey)
}
