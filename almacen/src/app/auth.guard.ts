import { Injectable } from '@angular/core';
import { CanActivateFn } from '@angular/router';
import { AuthService } from './auth.service';
import { inject } from '@angular/core';
import { Router } from '@angular/router';


export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router =  inject (Router);

  //Verificar si el usuario esta autenticado
  if (authService.isAuthenticated()) {
    return true;
  } else {
    router.navigate(['/inicio-sesion']);
    return false;
  }

};
