import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import {  Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

import { User } from './user';

@Injectable({
  providedIn: 'root'
})

export class UserService {

  private apiURL = "http://localhost:8000/api/";

  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
 }

 constructor(private httpClient: HttpClient) { }

  getAll(): Observable<User[]> {
    return this.httpClient.get<User[]>(this.apiURL + 'users')
    .pipe(
      catchError(this.errorHandler)
    )
  }

  getCategories(): Observable<any []>{
    return this.httpClient.get<any[]>(this.apiURL + 'categories')
    .pipe(
      catchError(this.errorHandler)
    )
  }

  getCountries(): Observable<any []>{
    return this.httpClient.get<any[]>(this.apiURL + 'countries')
    .pipe(
      catchError(this.errorHandler)
    )
  }

  create(user: any): Observable<User> {
    return this.httpClient.post<User>(this.apiURL + 'user/create', JSON.stringify(user), this.httpOptions)
    .pipe(
      catchError(this.errorHandler)
    )
  }

  find(id: number): Observable<User> {
    return this.httpClient.get<User>(this.apiURL + 'user/' + id)
    .pipe(
      catchError(this.errorHandler)
    )
  }

  update(id :any, user: any): Observable<User> {
    return this.httpClient.put<User>(this.apiURL + 'user/' + id, JSON.stringify(user), this.httpOptions)
    .pipe(
      catchError(this.errorHandler)
    )
  }

  delete(id: any){
    return this.httpClient.delete<User>(this.apiURL + 'user/' + id, this.httpOptions)
    .pipe(
      catchError(this.errorHandler)
    )
  }

  errorHandler(error: any) {
    let errorMessage = '';
    if(error.error instanceof ErrorEvent) {
      errorMessage = error.error.message;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    return throwError(errorMessage);
  }
}
