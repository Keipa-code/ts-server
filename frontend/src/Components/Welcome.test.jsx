import React, { render } from '@testing-library/react'
import Welcome from './Welcome'

test('renders welcome', () => {
  const { getByText } = render(<Welcome />)
  const h1Element = getByText(/Phone Directory/i)
  expect(h1Element).toBeInTheDocument()
})
