import AuthenticatedHttpClient from './AuthenticatedHttpClient.js';
export default class ProfilePhotoService extends AuthenticatedHttpClient {
  constructor() { super('../api'); }
  async upload(file) {
    const form = new FormData();
    form.append('photo', file);
    return this.postForm('/users/photo', form);
  }
}
